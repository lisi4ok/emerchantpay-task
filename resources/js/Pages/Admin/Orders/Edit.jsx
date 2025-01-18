import InputError from "@/Components/InputError";
import InputLabel from "@/Components/InputLabel";
import SelectInput from "@/Components/SelectInput";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, Link, useForm } from "@inertiajs/react";

export default function Create({ auth, order, statuses, orderStatus }) {
  const { data, setData, post, errors, reset } = useForm({
    status: order.status,
    _method: "PUT",
  });
  data['permissions'] = Array.from(statuses).map((p, i) => p);
  statuses.filter
  const onSubmit = (e) => {
    e.preventDefault();
      statuses.filter
    post(route("admin.orders.update", order.id));
  };

    return (
    <AuthenticatedLayout
      user={auth.user}
      header={
        <div className="flex justify-between items-center">
          <h2 className="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Order # {order.id}
          </h2>
        </div>
      }
    >
      <Head title="Orders" />

      <div className="py-12">
        <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div className="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <form
              onSubmit={onSubmit}
              className="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg"
            >

              <div className="p-6 text-gray-900 dark:text-gray-100">
                <div className="grid gap-1 grid-cols-2 mt-2">
                  <div>
                    <label className="font-bold text-lg">Order ID</label>
                    <p className="mt-1">{order.id}</p>
                  </div>
                  <div>
                    <label className="font-bold text-lg">Order Amount</label>
                    <p className="mt-1">{order.amount}</p>
                  </div>
                  <div>
                    <label className="font-bold text-lg">Order Status</label>
                    <p className="mt-1">{orderStatus}</p>
                  </div>
                  <div>
                    <label className="font-bold text-lg">User</label>
                    <p className="mt-1">{order.user.name}</p>
                    <p className="mt-1">{order.user.email}</p>
                  </div>

                  <div className="mt-4">
                    <label className="font-bold text-lg">Title</label>
                    <p className="mt-1">{order.title}</p>
                  </div>
                </div>
              </div>

              <div className="mt-4">
                <InputLabel htmlFor="status" value="Status"/>

                <SelectInput
                  name="status"
                      id="status"
                      className="mt-1 block w-full"
                      onChange={(e) => setData("status", e.target.value)}
                      defaultValue={order.status}
                    >
                      <option value="">Select Status</option>
                  {statuses.map((status, index) => (
                    (status != orderStatus) && (
                      <option value={index} key={index}>
                        {status}
                      </option>
                    )
                  ))}
                </SelectInput>

                <InputError message={errors.status} className="mt-2"/>
              </div>

              <div className="mt-4 text-right">
              <Link
                  href={route("admin.orders.index")}
                  className="bg-gray-100 py-1 px-3 text-gray-800 rounded shadow transition-all hover:bg-gray-200 mr-2"
                >
                  Cancel
                </Link>
                <button
                  className="bg-emerald-500 py-1 px-3 text-white rounded shadow transition-all hover:bg-emerald-600">
                  Submit
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </AuthenticatedLayout>
);
}
