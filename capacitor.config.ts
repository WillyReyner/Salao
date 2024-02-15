import { CapacitorConfig } from '@capacitor/cli';

const config: CapacitorConfig = {
  appId: 'com.example.app',
  appName: 'App',
  webDir: 'dist',
  "bundledWebRuntime": true,
  server: {
    "url": "http://localhost:8000",
    androidScheme: 'https'
  }
};

export default config;
