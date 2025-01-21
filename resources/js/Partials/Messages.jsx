import {usePage} from "@inertiajs/react";

export default function Messages() {
  const flash = usePage().props.flash;
  const error = flash.error;
  const success = flash.success;
  const info = flash.info;
  const warning = flash.warning;
  return (
    <>
      <div className="py-12">
        <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
          {error && (
            <>
              <div className="bg-rose-100 border-l-4 border-rose-500 text-rose-700 p-4 rounded-lg">
                <p className="text-lg font-semibold">Error</p>
                <p>{error}</p>
              </div>
            </>
          )}
          {success && (
            <>
              <div className="bg-emerald-100 border-l-4 border-emerald-500 text-emerald-700 p-4 rounded-lg">
                <p className="text-lg font-semibold">Success</p>
                <p>{success}</p>
              </div>
            </>
          )}
          {info && (
            <>
              <div className="bg-sky-100 border-l-4 border-sky-500 text-sky-700 p-4 rounded-lg">
                <p className="text-lg font-semibold">Info</p>
                <p>{info}</p>
              </div>
            </>
          )}
          {warning && (
            <>
              <div className="bg-amber-100 border-l-4 border-amber-500 text-amber-700 p-4 rounded-lg">
                <p className="text-lg font-semibold">warning</p>
                <p>{warning}</p>
              </div>
            </>
          )}
        </div>
      </div>
    </>
  );
}
