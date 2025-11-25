import { defineConfig } from 'vite';
import path from 'path';
import fs from 'fs';
import dotenv from 'dotenv';
import autoprefixer from 'autoprefixer';
import sftp from 'ssh2-sftp-client';

dotenv.config();

const SCRIPT_TYPE = 'js';
const STYLE_TYPE = 'scss';

// ------------------------------
//  Script & Style Entries
// ------------------------------
const scriptEntries = fs
  .readdirSync(path.resolve(__dirname, 'src/js/export'))
  .filter(file => file.endsWith('.js'))
  .map(file => file.replace('.js', ''));

const scssEntries = fs
  .readdirSync(path.resolve(__dirname, 'src/scss/export'))
  .filter(file => file.endsWith('.scss'))
  .map(file => file.replace('.scss', ''));

const generateInputs = (entries, type) => {
  const input = {};
  entries.forEach(name => {
    input[name] = path.resolve(__dirname, `src/${type}/export/${name}.${type}`);
  });
  return input;
};



// ------------------------------
// SFTP Upload Logic (same as gulp-sftp-up4)
// ------------------------------
const uploadDirToSFTP = async (localDir, remoteDir) => {
  const client = new sftp();

  await client.connect({
    host: process.env.HOST,
    username: process.env.USERNAME,
    password: process.env.PASSWORD,
    port: process.env.PORT,
  });

  const files = fs.readdirSync(localDir);
  for (const file of files) {
    const localPath = path.join(localDir, file);
    const remotePath = `${remoteDir}/${file}`;
    // Check if remote file exists
    let skip = false;

    try {
      const stat = await client.stat(remotePath);

      const localSize = fs.statSync(localPath).size;
      const remoteSize = stat.size;

      if (localSize === remoteSize) {
        skip = true; // identical → skip upload
      }
    } catch (e) {
      // file does not exist on remote → upload it
    }

    if (!skip) {
      await client.put(localPath, remotePath);
      console.log(`✔ Uploaded: ${file}`);
    } else {
      // console.log(`↪ Skipped (unchanged): ${file}`);
    }
  }

  await client.end();
};

// ------------------------------
// Vite Config
// ------------------------------
export default defineConfig({
  root: './src',
  build: {
    outDir: '../assets',
    emptyOutDir: false,
    sourcemap: false,
    cssDevSourcemap: true,

    rollupOptions: {
      input: {
        ...scriptEntries.length > 0 ? generateInputs(scriptEntries, SCRIPT_TYPE) : { empty: path.resolve(__dirname, 'src/js/export/_empty.js') },
        ...generateInputs(scssEntries, STYLE_TYPE),
      },

      output: {
        entryFileNames: 'js/[name].min.js',

        assetFileNames: assetInfo => {
          if (assetInfo.name.endsWith('.css')) {
            const clean = assetInfo.name.replace('.css', '');
            return `css/${clean}.min.css`;
          }
          return '[name].[ext]';
        },
      },
    },
  },

  // --------------------------------
  //          SCSS Compilation
  // --------------------------------
  css: {
    devSourcemap: true,
    preprocessorOptions: {
      scss: {
        // replicate your import style
        additionalData: `@use "../abstracts/" as *;`,
      },
    },
    postcss: {
      plugins: [autoprefixer()],
    },
  },

  // --------------------------------
  // Plugins
  // --------------------------------
  plugins: [
    {
      name: 'sftp-upload',
      apply: 'build',
      closeBundle: async () => {
        console.log('🚀 Uploading assets to server...\n');

        await uploadDirToSFTP(path.resolve(__dirname, 'assets/css'), `${process.env.REMOTE_PATH}/assets/css`);

        await uploadDirToSFTP(path.resolve(__dirname, 'assets/js'), `${process.env.REMOTE_PATH}/assets/js`);

        console.log('🎉 Upload completed!');
      },
    },
  ],
});
