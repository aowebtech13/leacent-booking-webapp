import "@testing-library/jest-dom/vitest";
import { vi } from "vitest";

declare global {
  // eslint-disable-next-line no-var
  var __TESTING__: boolean;
}

// Mock next/navigation
vi.mock("next/navigation", () => ({
  useRouter: () => ({
    replace: vi.fn(),
    push: vi.fn(),
    back: vi.fn(),
    forward: vi.fn(),
    refresh: vi.fn(),
  }),
  usePathname: () => "/",
  useSearchParams: () => new URLSearchParams(),
}));

// Mock react-apexcharts so it renders a predictable stub
vi.mock("react-apexcharts", () => ({
  default: ({ options, series, ...props }: any) => (
    <div
      data-testid="apex-chart"
      data-options={JSON.stringify(options)}
      data-series={JSON.stringify(series)}
      {...props}
    />
  ),
}));

// Mock react-slick
vi.mock("react-slick", () => {
  const Slider = ({ children }: any) => (
    <div data-testid="slider">{children}</div>
  );
  return { default: Slider };
});

// Mock next/image
vi.mock("next/image", () => ({
  default: ({ alt, src, ...props }: any) => (
    // eslint-disable-next-line @next/next/no-img-element
    <img alt={alt} src={src} {...props} />
  ),
}));

// Mock iconoir-react so icons render as plain spans
vi.mock("iconoir-react", () => ({
  ArrowRight: (props: any) => <span data-testid="icon-arrow-right" {...props} />,
  Calendar: (props: any) => <span data-testid="icon-calendar" {...props} />,
  Language: (props: any) => <span data-testid="icon-language" {...props} />,
  StarSolid: (props: any) => <span data-testid="icon-star" {...props} />,
}));

// Mock next/dynamic to render children directly (avoids lazy-loading complexity)
vi.mock("next/dynamic", () => ({
  default: (component: any) => component,
}));

// Suppress noisy React act warnings in tests
globalThis.__TESTING__ = true;