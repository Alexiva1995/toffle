import fs from 'fs';
import path from 'path';
import { fileURLToPath } from 'url';

const __dirname = path.dirname(fileURLToPath(import.meta.url));
const root = path.join(__dirname);

function copyDir(src, dest) {
  if (!fs.existsSync(src)) return;
  fs.mkdirSync(dest, { recursive: true });
  for (const entry of fs.readdirSync(src, { withFileTypes: true })) {
    const s = path.join(src, entry.name);
    const d = path.join(dest, entry.name);
    if (entry.isDirectory()) copyDir(s, d);
    else fs.copyFileSync(s, d);
  }
}

// En producción, quitar public/hot para que @vite() use los assets compilados
// en lugar del servidor de desarrollo (evita pantalla sin estilos tras el build)
const hotPath = path.join(root, 'public', 'hot');
try {
  if (fs.existsSync(hotPath)) {
    fs.unlinkSync(hotPath);
    console.log('Removed public/hot (use built assets)');
  }
} catch (e) {}

const dirs = [
  ['resources/vendors', 'public/vendors'],
  ['resources/fonts', 'public/fonts'],
  ['resources/images', 'public/images'],
  ['resources/data', 'public/data'],
];

for (const [src, dest] of dirs) {
  const srcPath = path.join(root, src);
  const destPath = path.join(root, dest);
  if (fs.existsSync(srcPath)) {
    copyDir(srcPath, destPath);
    console.log(`Copied ${src} -> ${dest}`);
  }
}
