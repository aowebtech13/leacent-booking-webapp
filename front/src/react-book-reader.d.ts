declare module "react-book-reader" {
  import * as React from "react";

  export interface ReactReaderProps {
    url: string | File;
    location?: string | number | null;
    title?: string;
    showToc?: boolean;
    tocChanged?: (toc: any[]) => void;
    onUpdateLocation?: (location: any) => void;
    LoadingView?: React.ReactNode;
    ErrorView?: React.ReactNode;
    style?: React.CSSProperties;
    className?: string;
    [key: string]: any;
  }

  export const ReactReader: React.FC<ReactReaderProps>;
  export default ReactReader;
}
