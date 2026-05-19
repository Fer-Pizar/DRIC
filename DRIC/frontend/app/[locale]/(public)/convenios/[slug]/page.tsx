type Props = {
  params: Promise<{
    locale: string;
    slug: string;
  }>;
};

export default async function AgreementDetailPage({
  params,
}: Props) {
  const { slug } = await params;

  return (
    <main className="min-h-screen bg-[#020617] px-6 py-24 text-white">
      <div className="mx-auto max-w-5xl">
        <p className="mb-4 text-sm uppercase tracking-[0.3em] text-cyan-300">
          Agreement Detail
        </p>

        <h1 className="text-5xl font-bold leading-tight">
          {slug.replaceAll("-", " ")}
        </h1>

        <div className="mt-12 rounded-[32px] border border-white/10 bg-white/[0.03] p-10 backdrop-blur-xl">
          <p className="text-lg leading-8 text-white/70">
            This page will later connect dynamically to the CMS
            and database content for each agreement.
          </p>
        </div>
      </div>
    </main>
  );
}