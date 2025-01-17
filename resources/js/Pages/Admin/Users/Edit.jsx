import InputError from "@/Components/InputError";
import InputLabel from "@/Components/InputLabel";
import SelectInput from "@/Components/SelectInput";
import TextAreaInput from "@/Components/TextAreaInput";
import Checkbox from "@/Components/Checkbox";
import TextInput from "@/Components/TextInput";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, Link, useForm } from "@inertiajs/react";

export default function Create({ auth, user, roles, userRoles, error }) {
  const { data, setData, post, errors, reset } = useForm({
    name: user.name || "",
    email: user.email || "",
    amount: user.amount || "",
    description: user.description || "",
    password: "",
    password_confirmation: "",
    roles: userRoles || [],
    role: user.role || "",
    _method: "PUT",
  });

  const onSubmit = (e) => {
    e.preventDefault();
    data['roles'] = Array.from(document.querySelectorAll('input[name="roles[]"]:checked')).map((p) => p.value);

    post(route("admin.users.update", user.id));
  };

    return (
    <AuthenticatedLayout
      user={auth.user}
      header={
        <div className="flex justify-between items-center">
          <h2 className="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Edit user "{user.name}"
          </h2>
        </div>
      }
    >
      <Head title="Users" />

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
              <div className="mt-4">
                <InputLabel htmlFor="name" value="Name"/>

                <TextInput
                  id="name"
                  type="text"
                  name="name"
                  value={data.name}
                  className="mt-1 block w-full"
                  isFocused={true}
                  onChange={(e) => setData("name", e.target.value)}
                />

                <InputError message={errors.name} className="mt-2"/>
              </div>
              <div className="mt-4">
                <InputLabel htmlFor="email" value="Email"/>

                <TextInput
                  id="email"
                  type="text"
                  name="email"
                  value={data.email}
                  className="mt-1 block w-full"
                  onChange={(e) => setData("email", e.target.value)}
                />

                <InputError message={errors.email} className="mt-2"/>
              </div>

              <div className="mt-4">
                <InputLabel htmlFor="password" value="Password"/>

                <TextInput
                  id="password"
                  type="password"
                  name="password"
                  value={data.password}
                  className="mt-1 block w-full"
                  onChange={(e) => setData("password", e.target.value)}
                />

                <InputError message={errors.password} className="mt-2"/>
              </div>

              <div className="mt-4">
                <InputLabel
                  htmlFor="password_confirmation"
                  value="Confirm Password"
                />

                <TextInput
                  id="password_confirmation"
                  type="password"
                  name="password_confirmation"
                  value={data.password_confirmation}
                  className="mt-1 block w-full"
                  onChange={(e) =>
                    setData("password_confirmation", e.target.value)
                  }
                />

                <InputError
                  message={errors.password_confirmation}
                  className="mt-2"
                />
              </div>

              <div className="mt-4">
                <InputLabel htmlFor="amount" value="Amount"/>

                <TextInput
                  id="amount"
                  type="text"
                  name="amount"
                  value={data.amount}
                  className="mt-1 block w-full"
                  onChange={(e) => setData("amount", e.target.value)}
                />

                <InputError message={errors.amount} className="mt-2"/>
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

              <div className="mt-4">
                <InputLabel htmlFor="role_id" value="Role"/>

                <SelectInput
                  name="role"
                  id="role"
                  className="mt-1 block w-full"
                  onChange={(e) => setData("role", e.target.value)}
                >
                  <option value="">Select Role</option>
                  {roles.map((role) => (
                    <option value={role.id}
                            key={role.id}
                            selected={userRoles.includes(role.id)}
                    >
                      {role.name}
                    </option>
                  ))}
                </SelectInput>

                <InputError message={errors.role} className="mt-2"/>
              </div>

              <div className="mt-4 block">
                {
                  roles.map(role => {
                    return (
                      <label className="flex items-center" key={role.id}>
                        <Checkbox
                          name="roles[]"
                          value={role.id}
                          defaultChecked={userRoles.includes(role.id)}
                        />
                        <span className="ms-2 text-sm text-gray-600 dark:text-gray-400">
                          {role.name}
                        </span>
                      </label>
                    );
                  })
                }

                <InputError message={errors.roles} className="mt-2"/>
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
