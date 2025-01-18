import Pagination from "@/Components/Pagination";
import TextInput from "@/Components/TextInput";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import TableHeading from "@/Components/TableHeading";
import { Head, Link, router } from "@inertiajs/react";
import SelectInput from "@/Components/SelectInput";

export default function Index({ auth, transactions, transactionsTypes, queryParams = null }) {
  queryParams = queryParams || {};
  const searchFieldChanged = (name, value) => {
    if (value) {
      queryParams[name] = value;
    } else {
      delete queryParams[name];
    }

    router.get(route("merchant.transactions"), queryParams);
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
    router.get(route("merchant.transactions"), queryParams);
  };

  return (
    <AuthenticatedLayout
      user={auth.user}
      header={
        <div className="flex justify-between items-center">
          <h2 className="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Transactions
          </h2>
        </div>
      }
    >
      <Head title="Transactions" />

      <div className="py-12">
        <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div className="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div className="p-6 text-gray-900 dark:text-gray-100">
              <div className="overflow-auto">
                <table className="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                  <thead className="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 border-b-2 border-gray-500">
                    <tr className="text-nowrap">
                      <TableHeading
                        name="type"
                        sort_field={queryParams.sort_field}
                        sort_direction={queryParams.sort_direction}
                        sortChanged={sortChanged}
                      >
                        Type
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
                        name="created_at"
                        sort_field={queryParams.sort_field}
                        sort_direction={queryParams.sort_direction}
                        sortChanged={sortChanged}
                      >
                        Create Date
                      </TableHeading>
                    </tr>
                  </thead>
                  <thead className="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 border-b-2 border-gray-500">
                  <tr className="text-nowrap">
                    <th className="px-3 py-3">
                      <SelectInput
                        name="type"
                        className="mt-1 block w-full"
                        defaultValue={queryParams.type}
                        onChange={(e) =>
                          searchFieldChanged("type", e.target.value)
                        }
                      >
                        <option value="">Type</option>
                        {transactionsTypes.map((type, index) => (
                          <option value={index} key={index}>
                            {type}
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
                        onKeyPress={(e) => onKeyPress("Amount", e)}
                      />
                    </th>
                    <th className="px-3 py-3"></th>
                  </tr>
                  </thead>
                  <tbody>
                  {transactions.data.map((transaction) => (
                    <tr
                      className="bg-white border-b dark:bg-gray-800 dark:border-gray-700"
                      key={transaction.id}
                    >
                      <td className="px-3 py-2">{transaction.type}</td>
                      <td className="px-3 py-2">{transaction.amount}</td>
                      <td className="px-3 py-2 text-nowrap">
                        {transaction.created_at}
                      </td>
                    </tr>
                  ))}
                  </tbody>
                </table>
              </div>
              <Pagination links={transactions.meta.links} />
            </div>
          </div>
        </div>
      </div>
    </AuthenticatedLayout>
  );
}
