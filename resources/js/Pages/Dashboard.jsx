import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import {Head, Link, usePage} from '@inertiajs/react';

export default function Dashboard({ role, amount }) {
  const user = usePage().props.auth.user;
    return (
        <AuthenticatedLayout
            header={
                <h2 className="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                    Dashboard
                </h2>
            }
        >
            <Head title="Dashboard" />


          {(user.role == 3) ?
            <div className="py-12">
              <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                  <div className="p-6 text-gray-900 dark:text-gray-100">
                    You're logged in as {role}!
                  </div>
                </div>
              </div>
            </div>
            :
            <div className="py-12">
              <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">

                <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">

                  <div className="p-6 text-gray-900 dark:text-gray-100">
                    <h2 className="text-lg font-medium text-gray-900 dark:text-gray-100">
                      Amount
                    </h2>

                    <p className="mt-1 text-sm text-gray-600 dark:text-gray-400">
                      Your amount is: <strong>{amount}</strong>
                    </p>
                  </div>


                  <div className="p-6 text-gray-900 dark:text-gray-100">
                    <Link
                      href={route("merchant.money.add")}
                      className="bg-emerald-500 py-1 px-3 text-white rounded shadow transition-all hover:bg-emerald-600"
                    >
                      Add Money
                    </Link>
                  </div>
                  <div className="p-6 text-gray-900 dark:text-gray-100">
                    <Link
                      href={route("merchant.money.transfer")}
                      className="bg-emerald-500 py-1 px-3 text-white rounded shadow transition-all hover:bg-emerald-600"
                    >
                      Send Money
                    </Link>
                  </div>
                </div>
              </div>
            </div>
          }
        </AuthenticatedLayout>
    );
}
