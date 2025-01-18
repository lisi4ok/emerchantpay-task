import Pagination from "@/Components/Pagination";
import TextInput from "@/Components/TextInput";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import TableHeading from "@/Components/TableHeading";
import { Head, Link, router } from "@inertiajs/react";
import SelectInput from "@/Components/SelectInput.jsx";

export default function Index({ auth, orders, statuses, queryParams = null }) {
  queryParams = queryParams || {};
  const searchFieldChanged = (name, value) => {
    if (value) {
      queryParams[name] = value;
    } else {
      delete queryParams[name];
    }

    router.get(route("admin.orders.index"), queryParams);
  };

  const onKeyPress = (name, e) => {
    if (e.key !== "Enter") return;

    searchFieldChanged(name, e.target.value);
  };

  const sortChanged = (name) => {
    if (name === queryParams.sort_field) {
      if (queryParams.sort_direction === "asc") {
        queryParams.sort_direction = "desc";
      } else {
        queryParams.sort_direction = "asc";
      }
    } else {
      queryParams.sort_field = name;
      queryParams.sort_direction = "asc";
    }
    router.get(route("admin.orders.index"), queryParams);
  };

  const deleteOrder = (order) => {
    if (!window.confirm("Are you sure you want to delete the order?")) {
      return;
    }
    router.delete(route("admin.orders.destroy", order.id));
  };

  return (
    <AuthenticatedLayout
      user={auth.user}
      header={
        <div className="flex justify-between items-center">
          <h2 className="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Orders
          </h2>
          <Link
            href={route("admin.orders.create")}
            className="bg-emerald-500 py-1 px-3 text-white rounded shadow transition-all hover:bg-emerald-600"
          >
            Create new
          </Link>
        </div>
      }
    >
      <Head title="Users" />

      <div className="py-12">
        <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div className="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div className="p-6 text-gray-900 dark:text-gray-100">
              <div className="overflow-auto">
                <table className="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                  <thead className="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 border-b-2 border-gray-500">
                    <tr className="text-nowrap">
                      <TableHeading
                        name="id"
                        sort_field={queryParams.sort_field}
                        sort_direction={queryParams.sort_direction}
                        sortChanged={sortChanged}
                      >
                        ID
                      </TableHeading>

                      <TableHeading
                        name="status"
                        sort_field={queryParams.sort_field}
                        sort_direction={queryParams.sort_direction}
                        sortChanged={sortChanged}
                      >
                        Status
                      </TableHeading>

                      <TableHeading
                          name="amount"
                          sort_field={queryParams.sort_field}
                          sort_direction={queryParams.sort_direction}
                          sortChanged={sortChanged}
                      >
                          Amount
                      </TableHeading>

                      <TableHeading
                        name="title"
                        sort_field={queryParams.sort_field}
                        sort_direction={queryParams.sort_direction}
                        sortChanged={sortChanged}
                      >
                        Title
                      </TableHeading>

                      <TableHeading
                        name="created_at"
                        sort_field={queryParams.sort_field}
                        sort_direction={queryParams.sort_direction}
                        sortChanged={sortChanged}
                      >
                        Create Date
                      </TableHeading>

                      <th className="px-3 py-3 text-right">Actions</th>
                    </tr>
                  </thead>
                  <thead className="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 border-b-2 border-gray-500">
                  <tr className="text-nowrap">
                    <th className="px-3 py-3"></th>
                    <th className="px-3 py-3">
                      <SelectInput
                        name="status"
                        className="mt-1 block w-full"
                        defaultValue={queryParams.status}
                        onChange={(e) =>
                          searchFieldChanged("status", e.target.value)
                        }
                      >
                        <option value="">Status</option>
                        {statuses.map((status, index) => (
                          <option value={index} key={index}>
                            {status}
                          </option>
                        ))}
                      </SelectInput>
                    </th>
                    <th className="px-3 py-3">
                      <TextInput
                        className="w-full"
                        defaultValue={queryParams.amount}
                        placeholder="Amount"
                        onBlur={(e) =>
                          searchFieldChanged("amount", e.target.value)
                        }
                        onKeyPress={(e) => onKeyPress("amount", e)}
                      />
                    </th>
                    <th className="px-3 py-3">
                      <TextInput
                        className="w-full"
                        defaultValue={queryParams.title}
                        placeholder="Title"
                        onBlur={(e) =>
                          searchFieldChanged("title", e.target.value)
                        }
                        onKeyPress={(e) => onKeyPress("title", e)}
                      />
                    </th>
                    <th className="px-3 py-3"></th>
                    <th className="px-3 py-3"></th>
                  </tr>
                  </thead>
                  <tbody>
                  {orders.data.map((order) => (
                    <tr
                      className="bg-white border-b dark:bg-gray-800 dark:border-gray-700"
                      key={order.id}
                    >
                      <td className="px-3 py-2">{order.id}</td>
                      <th className="px-3 py-2 text-nowrap">
                        {order.status}
                      </th>
                      <td className="px-3 py-2">{order.amount}</td>
                      <td className="px-3 py-2">{order.title}</td>
                      <td className="px-3 py-2 text-nowrap">
                        {order.created_at}
                      </td>
                      <td className="px-3 py-2 text-nowrap">
                        <Link
                          href={route("admin.orders.show", order.id)}
                          className="font-medium text-blue-600 dark:text-blue-500 hover:underline mx-1"
                        >
                          View
                        </Link>
                        <Link
                          href={route("admin.orders.edit", order.id)}
                          className="font-medium text-blue-600 dark:text-blue-500 hover:underline mx-1"
                        >
                          Edit
                        </Link>
                        <button
                          onClick={(e) => deleteOrder(order)}
                          className="font-medium text-red-600 dark:text-red-500 hover:underline mx-1"
                        >
                          Delete
                        </button>
                      </td>
                      </tr>
                    ))}
                  </tbody>
                </table>
              </div>
              <Pagination links={orders.meta.links} />
            </div>
          </div>
        </div>
      </div>
    </AuthenticatedLayout>
  );
}
