import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import {Head, Link} from "@inertiajs/react";
export default function Show({ auth, role, permissions, queryParams }) {
  return (
    <AuthenticatedLayout
      user={auth.user}
      header={
        <h2 className="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
          {`Role "${role.name}"`}
        </h2>
      }
    >
      <Head title={`Role "${role.name}"`} />

      <div className="py-12">
        <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div className="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div className="p-6 text-gray-900 dark:text-gray-100">
              <div className="grid gap-1 grid-cols-2 mt-2">
                <div>
                  <div>
                    <label className="font-bold text-lg">Role ID</label>
                    <p className="mt-1">{role.id}</p>
                  </div>
                  <div className="mt-4">
                    <label className="font-bold text-lg">Name</label>
                    <p className="mt-1">{role.name}</p>
                  </div>
                </div>
                <div>
                  <div className="mt-4">
                    <label className="font-bold text-lg">Create Date</label>
                    <p className="mt-1">{role.created_at}</p>
                  </div>
                </div>
              </div>
              <div className="mt-4">
                <label className="font-bold text-lg">Permissions</label>
                <div className="mt-4 block">
                  <ul>
                    {
                      permissions.map(permission => {
                        return (
                          <li key={permission.id}>
                            <span className="ms-2 text-sm text-gray-600 dark:text-gray-400">
                              {permission.name}
                            </span>
                          </li>
                        );
                      })
                    }
                  </ul>
                </div>
              </div>

              <div className="mt-4 text-right">
                <Link
                  href={route("admin.roles.index")}
                  className="bg-gray-100 py-1 px-3 text-gray-800 rounded shadow transition-all hover:bg-gray-200 mr-2"
                >
                  Back
                </Link>
              </div>
            </div>
          </div>
        </div>
      </div>
    </AuthenticatedLayout>
  );
}
