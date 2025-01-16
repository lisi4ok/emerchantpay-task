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
    </>
  );
}
