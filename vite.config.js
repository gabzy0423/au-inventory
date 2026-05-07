import { defineConfig } from 'vite';
import tailwindcss from 'tailwindcss';
import autoprefixer from 'autoprefixer';

export default defineConfig({
    css: {
        postcss: {
            plugins: [
                tailwindcss(),
                autoprefixer(),
            ],
        },
    },
    server: {
        port: 5174,
        strictPort: true,
        cors: true,
        origin: 'http://localhost:5174',
    },
    build: {
        outDir: 'public/build',
        emptyOutDir: true,
        manifest: true,
        rollupOptions: {
            input: 'resources/js/app.js',
        }
    }
});
