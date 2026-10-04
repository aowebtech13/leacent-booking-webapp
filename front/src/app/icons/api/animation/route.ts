export const revalidate = 3600;
export async function GET() {
  try {
    const response = await fetch(
      "https://api.iconify.design/collection?prefix=line-md&chars=true&aliases=true",
      { cache: "force-cache" } // optional for ISR caching
    );
    if (!response.ok) {
      return new Response("Failed to fetch icons", { status: 500 });
    }
    const data = await response.json();
    const categories = Object.keys(data.categories);
    const iconList = categories.map((icon) =>
      data.categories[icon].map((item: string[]) => item)
    );
    return new Response(JSON.stringify(iconList), {
      headers: {
        "Content-Type": "application/json",
        "Cache-Control": "public, max-age=3600, stale-while-revalidate=30",
      },
    });
  } catch (error) {
    return new Response("Internal Server Error", { status: 500 });
  }
}
