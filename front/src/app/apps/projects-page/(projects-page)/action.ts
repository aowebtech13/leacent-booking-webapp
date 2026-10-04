"use server";

export async function submitProject(formData: FormData) {
  const projectName = formData.get("projectName")?.toString();
  const startDate = formData.get("startDate")?.toString();
  const endDate = formData.get("endDate")?.toString();
  const pricing = formData.get("pricing")?.toString();
  const description = formData.get("description")?.toString();
  const file = formData.get("image") as File | null;

  await new Promise((res) => setTimeout(res, 500));

  return {
    projectName,
    startDate,
    endDate,
    pricing,
    description,
    fileName: file?.name,
    fileType: file?.type,
  };
}
