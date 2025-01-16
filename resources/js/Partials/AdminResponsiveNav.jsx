import ResponsiveNavLink from "@/Components/ResponsiveNavLink";
export default function AdminResponsiveNav({}) {
  return (
    <>
      <ResponsiveNavLink
        href={route('admin.users.index')}
        active={route().current('admin.users.index')}
      >
        Users
      </ResponsiveNavLink>
      <ResponsiveNavLink
        href={route('admin.roles.index')}
        active={route().current('admin.roles.index')}
      >
        Roles
      </ResponsiveNavLink>
    </>
  );
}
