import sharp from 'sharp';
import { stat } from 'node:fs/promises';
import path from 'node:path';
import { fileURLToPath } from 'node:url';

const projectRoot = fileURLToPath(
    new URL('../', import.meta.url)
);

const source = path.join(
    projectRoot,
    'public/images/lander-celestial.png'
);

const destination = path.join(
    projectRoot,
    'public/images/lander-celestial.webp'
);

try {
    const original = await stat(source);

    const optimized = await sharp(source)
        .resize({
            width: 1200,
            withoutEnlargement: true,
        })
        .webp({
            quality: 90,
            effort: 6,
        })
        .toFile(destination);

    const reduction = (
        (1 - optimized.size / original.size) * 100
    ).toFixed(1);

    console.log(
        `Original: ${(original.size / 1024).toFixed(0)} KB`
    );

    console.log(
        `WebP: ${(optimized.size / 1024).toFixed(0)} KB`
    );

    console.log(`Size reduction: ${reduction}%`);
} catch (error) {
    console.error(`Brand optimization failed: ${error.message}`);
    process.exitCode = 1;
}
