import InputError from "@/Components/InputError";
import InputLabel from "@/Components/InputLabel";
import TextInput from "@/Components/TextInput";
import SelectInput from "@/Components/SelectInput";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, Link, useForm } from "@inertiajs/react";
import TextAreaInput from "@/Components/TextAreaInput";

export default function Create({ auth, users, types }) {
  const { data, setData, post, errors, reset } = useForm({
    user_id: "",
    type: "",
    amount: "",
    description: "",
  });

  const onSubmit = (e) => {
    e.preventDefault();

    post(route("admin.transactions.store"));
  };

  return (
    <AuthenticatedLayout
      user={auth.user}
      header={
        <div className="flex justify-between items-center">
          <h2 className="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Create new
          </h2>
        </div>
      }
    >
      <Head title="Transactions" />

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
                <InputLabel htmlFor="type" value="Type"/>

                <SelectInput
                  name="type"
                  id="type"
                  className="mt-1 block w-full"
                  onChange={(e) => setData("type", e.target.value)}
                >
                  <option value="">Select Type</option>
                  {types.map((transactionType, index) => (
                    <option value={index} key={index}>
                      {transactionType}
                    </option>
                  ))}
                </SelectInput>

                <InputError message={errors.type} className="mt-2"/>
              </div>

              <div className="mt-4">
                <InputLabel htmlFor="user_id" value="User"/>

                <SelectInput
                  name="user_id"
                  id="user_id"
                  className="mt-1 block w-full"
                  onChange={(e) => setData("user_id", e.target.value)}
                >
                  <option value="">Select User</option>
                  {users.map((user) => (
                    <option value={user.id} key={user.id}>
                      {user.name}
                    </option>
                  ))}
                </SelectInput>

                <InputError message={errors.user_id} className="mt-2"/>
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
                  href={route("admin.transactions.index")}
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
