// Define types for Vue files to be properly recognized by TypeScript
declare module "*.vue" {
  import type { DefineComponent } from "vue";
  const component: DefineComponent<{}, {}, any>;
  export default component;
}

// Define types for environment variables
interface ImportMetaEnv {
  readonly VITE_APP_NAME: string;
  readonly VITE_APP_URL: string;
  readonly VITE_ASSET_URL?: string;
}

interface ImportMeta {
  readonly env: ImportMetaEnv;
}