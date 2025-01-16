import InputError from "@/Components/InputError";
import InputLabel from "@/Components/InputLabel";
import Checkbox from "@/Components/Checkbox";
import TextInput from "@/Components/TextInput";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, Link, useForm } from "@inertiajs/react";

export default function Create({ auth, role, permissions, rolePermissions }) {
  const { data, setData, post, errors, reset } = useForm({
    name: role.name || "",
    permissions: rolePermissions || [],
    _method: "PUT",
  });

  const onSubmit = (e) => {
    e.preventDefault();
    data['permissions'] = Array.from(document.querySelectorAll('input[name="permissions[]"]:checked')).map((p) => p.value);

    post(route("admin.roles.update", role.id));
  };

    return (
    <AuthenticatedLayout
      user={auth.user}
      header={
        <div className="flex justify-between items-center">
          <h2 className="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Edit role "{role.name}"
          </h2>
        </div>
      }
    >
      <Head title="Roles" />

      <div className="py-12">
        <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
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

              <div className="mt-4 block">
                {
                  permissions.map(permission => {
                    return (
                      <label className="flex items-center" key={permission.id}>
                        <Checkbox
                          name="permissions[]"
                          value={permission.id}
                          defaultChecked={rolePermissions.includes(permission.id)}
                        />
                        <span className="ms-2 text-sm text-gray-600 dark:text-gray-400">
                          {permission.name}
                        </span>
                      </label>
                    );
                  })
                }

                <InputError message={errors.permissions} className="mt-2"/>
              </div>

              <div className="mt-4 text-right">
                <Link
                  href={route("admin.roles.index")}
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
