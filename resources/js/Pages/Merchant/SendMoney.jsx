import InputError from "@/Components/InputError";
import InputLabel from "@/Components/InputLabel";
import TextInput from "@/Components/TextInput";
import SelectInput from "@/Components/SelectInput";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, Link, useForm } from "@inertiajs/react";
import TextAreaInput from "@/Components/TextAreaInput";
import Checkbox from "@/Components/Checkbox";

export default function AddMoney({ auth, users, amount, error }) {
  const { data, setData, post, errors, reset } = useForm({
    user_id: "",
    amount: "",
  });

  const onSubmit = (e) => {
    e.preventDefault();
    post(route("merchant.money.transfer"));
  };

  return (
    <AuthenticatedLayout ser={auth.user}
      header={
        <h2 className="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
          Send Money
        </h2>
      }
    >
      <Head title="Send Money" />

      <div className="py-12">
        <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
          {error && (
            <div className="bg-rose-500 py-2 px-4 text-white rounded mb-4">
              {error}
            </div>
          )}
          <div className="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <form
              onSubmit={onSubmit}
              className="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg"
            >
              <section className="max-w-xl">
                <header>
                  <h2 className="text-lg font-medium text-gray-900 dark:text-gray-100">
                    Amount
                  </h2>

                  <p className="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    Your amount is: <strong>{amount}</strong>
                  </p>
                </header>
              </section>

                <div className="mt-4">
                  <InputLabel htmlFor="amount" value="Amount" className="reqired"/>

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
                  <InputLabel htmlFor="user_id" value="User" className="reqired"/>

                  <SelectInput
                    name="user_id"
                    id="user_id"
                    className="mt-1 block w-full"
                    onChange={(e) => setData("user_id", e.target.value)}
                  >
                    <option value="">Select User</option>
                    {users.data.map((user) => (
                      <option value={user.id} key={user.id}>
                        {user.name}
                      </option>
                    ))}
                  </SelectInput>

                  <InputError message={errors.user_id} className="mt-2"/>
                </div>

                <div className="mt-4 text-right">
                  <Link
                    href={route("dashboard")}
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
