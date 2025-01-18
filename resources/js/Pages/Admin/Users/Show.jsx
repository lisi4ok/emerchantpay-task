import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import {Head, Link} from "@inertiajs/react";
export default function Show({ auth, user, queryParams }) {
  return (
    <AuthenticatedLayout
      user={auth.user}
      header={
        <h2 className="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
          {`User "${user.name}"`}
        </h2>
      }
    >
      <Head title={`User "${user.name}"`} />
      <div className="py-12">
        <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div className="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div className="p-6 text-gray-900 dark:text-gray-100">
              <div className="grid gap-1 grid-cols-2 mt-2">
                <div>
                  <div>
                    <label className="font-bold text-lg">User ID</label>
                    <p className="mt-1">{user.id}</p>
                  </div>
                  <div className="mt-4">
                    <label className="font-bold text-lg">Name</label>
                    <p className="mt-1">{user.name}</p>
                  </div>

                  <div className="mt-4">
                    <label className="font-bold text-lg">Status</label>
                    <p className="mt-1">
                      <span
                        className={
                          "px-2 py-1 rounded " +
                          user.status
                        }
                      >
                        {user.status}
                      </span>
                    </p>
                  </div>
                </div>
                <div>
                  <div className="mt-4">
                    <label className="font-bold text-lg">Create Date</label>
                    <p className="mt-1">{user.created_at}</p>
                  </div>
                  <div className="mt-4">
                    <label className="font-bold text-lg">Created By</label>
                    <p className="mt-1">{(user.created_by) ? user.created_by.name : ''}</p>
                  </div>
                  <div className="mt-4">
                    <label className="font-bold text-lg">Updated By</label>
                    <p className="mt-1">{(user.updated_by) ? user.updated_by.name : ''}</p>
                  </div>
                </div>
              </div>
              <div className="mt-4">
                <label className="font-bold text-lg">Amount</label>
                <p className="mt-1">{user.amount}</p>
              </div>
              <div className="mt-4">
                <label className="font-bold text-lg">Description</label>
                <p className="mt-1">{user.description}</p>
              </div>

              <div className="mt-4 text-right">
                <Link
                  href={route("admin.users.index")}
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
