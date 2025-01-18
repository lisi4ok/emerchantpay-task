import NavLink from "@/Components/NavLink";
export default function AdminNav({}) {
  return (
    <>
      <NavLink
        href={route('admin.users.index')}
        active={route().current('admin.users.index')}
      >
        Users
      </NavLink>
      <NavLink
        href={route('admin.roles.index')}
        active={route().current('admin.roles.index')}
      >
        Roles
      </NavLink>
      <NavLink
        href={route('admin.orders.index')}
        active={route().current('admin.orders.index')}
      >
        Orders
      </NavLink>
      <NavLink
        href={route('admin.transactions.index')}
        active={route().current('admin.transactions.index')}
      >
        Transactions
      </NavLink>
    </>
  );
}
