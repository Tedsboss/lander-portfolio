import sharp from 'sharp';
import path from 'node:path';
import { fileURLToPath } from 'node:url';

const projectRoot = fileURLToPath(
    new URL('../', import.meta.url)
);

const imagesRoot = path.join(projectRoot, 'public', 'images');

const backgrounds = [
    {
        source: 'portfolio-background.png',
        output: 'portfolio-background-mobile.webp',
        position: 'right',
    },
    {
        source: 'portfolio-dota-background.png',
        output: 'portfolio-dota-background-mobile.webp',
        position: 'right',
    },
];

let failed = false;

for (const background of backgrounds) {
    try {
        const result = await sharp(
            path.join(imagesRoot, background.source)
        )
            .rotate()
            .resize({
                width: 720,
                height: 1280,
                fit: 'cover',
                position: background.position,
            })
            .webp({
                quality: 82,
                effort: 6,
            })
            .toFile(
                path.join(imagesRoot, background.output)
            );

        console.log(
            `${background.output}: ` +
            `${Math.round(result.size / 1024)} KB`
        );
    } catch (error) {
        failed = true;

        console.error(
            `Failed ${background.source}: ${error.message}`
        );
    }
}

if (failed) {
    process.exitCode = 1;
}
