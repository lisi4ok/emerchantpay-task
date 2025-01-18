import InputError from "@/Components/InputError";
import InputLabel from "@/Components/InputLabel";
import SelectInput from "@/Components/SelectInput";
import TextAreaInput from "@/Components/TextAreaInput";
import TextInput from "@/Components/TextInput";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, Link, useForm } from "@inertiajs/react";

export default function Create({ auth, order, users, statuses }) {
  const { data, setData, post, errors, reset } = useForm({
    user_id: order.user_id ,
    status: order.status,
    amount: order.amount,
    title: order.title,
    description: order.description,
    _method: "PUT",
  });

  const onSubmit = (e) => {
    e.preventDefault();

    post(route("admin.orders.update", order.id));
  };

    return (
    <AuthenticatedLayout
      user={auth.user}
      header={
        <div className="flex justify-between items-center">
          <h2 className="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Edit Order # {order.id}
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
              <div className="mt-4">
                <InputLabel htmlFor="amount" value="Amount"/>

                <TextInput
                  id="amount"
                  type="text"
                  name="amount"
                  value={data.amount}
                  className="mt-1 block w-full"
                  isFocused={true}
                  onChange={(e) => setData("amount", e.target.value)}
                />

                <InputError message={errors.amount} className="mt-2"/>
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
                    <option value={index}
                            key={index}
                            selected={order.status === index}
                    >
                      {status}
                    </option>
                  ))}
                </SelectInput>

                <InputError message={errors.status} className="mt-2"/>
              </div>

              <div className="mt-4">
                <InputLabel htmlFor="user_id" value="User"/>

                <SelectInput
                  name="user_id"
                  id="user_id"
                  className="mt-1 block w-full"
                  onChange={(e) => setData("user_id", e.target.value)}
                  defaultValue={order.user_id}
                >
                  <option value="">Select User</option>
                  {users.map((user) => (
                    <option value={user.id}
                            key={user.id}
                            selected={(order.user_id === user.id)}
                    >
                      {user.name}
                    </option>
                  ))}
                </SelectInput>

                <InputError message={errors.user_id} className="mt-2"/>
              </div>


              <div className="mt-4">
                <InputLabel htmlFor="title" value="Title"/>

                <TextInput
                  id="title"
                  type="text"
                  name="title"
                  value={data.title}
                  className="mt-1 block w-full"
                  onChange={(e) => setData("title", e.target.value)}
                />

                <InputError message={errors.title} className="mt-2"/>
              </div>

              <div className="mt-4">
                <InputLabel htmlFor="description" value="Description"/>

                <TextAreaInput
                  id="description"
                  type="text"
                  name="description"
                  value={data.description}
                  className="mt-1 block w-full"
                  onChange={(e) => setData("description", e.target.value)}
                />

                <InputError message={errors.description} className="mt-2"/>
              </div>

              <div className="mt-4 text-right">
                <Link
                  href={route("admin.users.index")}
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
