import sharp from 'sharp';
import { mkdir, readdir, stat } from 'node:fs/promises';
import path from 'node:path';
import { fileURLToPath } from 'node:url';

const projectRoot = fileURLToPath(new URL('../', import.meta.url));
const imagesRoot = path.join(projectRoot, 'public', 'images');

const projectFolders = [
    'DIREK',
    'EIGIS',
    'ICC',
    'NPMCS',
    'IMP',
    'PPMS',
    'SAGAD',
    'SDS',
    'TIMTA',
    'CHICKENLICIOUS',
];

const variants = [
    { name: 'thumbs', width: 256, quality: 82 },
    { name: 'cards', width: 960, quality: 88 },
];

let generated = 0;
let failed = 0;
let originalBytes = 0;
let previewBytes = 0;

for (const folder of projectFolders) {
    const sourceFolder = path.join(imagesRoot, folder);

    let files;

    try {
        files = await readdir(sourceFolder, { withFileTypes: true });
    } catch (error) {
        console.error(`Cannot read ${folder}: ${error.message}`);
        failed++;
        continue;
    }

    for (const file of files) {
        if (!file.isFile() || !/\.(png|jpe?g|webp)$/i.test(file.name)) {
            continue;
        }

        const source = path.join(sourceFolder, file.name);

        try {
            const sourceInfo = await stat(source);
            originalBytes += sourceInfo.size;

            for (const variant of variants) {
                const destinationFolder = path.join(
                    imagesRoot,
                    'optimized',
                    variant.name,
                    folder
                );

                await mkdir(destinationFolder, { recursive: true });

                const destination = path.join(
                    destinationFolder,
                    `${file.name}.webp`
                );

                const result = await sharp(source)
                    .rotate()
                    .resize({
                        width: variant.width,
                        withoutEnlargement: true,
                    })
                    .webp({
                        quality: variant.quality,
                        effort: 5,
                    })
                    .toFile(destination);

                previewBytes += result.size;
                generated++;

                console.log(
                    `${folder}/${file.name} → ${variant.name}: ` +
                    `${Math.round(result.size / 1024)} KB`
                );
            }
        } catch (error) {
            console.error(`Failed ${folder}/${file.name}: ${error.message}`);
            failed++;
        }
    }
}

console.log(`\nGenerated ${generated} preview files.`);
console.log(`Original screenshots: ${(originalBytes / 1048576).toFixed(2)} MB`);
console.log(`All preview copies: ${(previewBytes / 1048576).toFixed(2)} MB`);

if (failed > 0) {
    console.error(`${failed} file or folder errors occurred.`);
    process.exitCode = 1;
}
