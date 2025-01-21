import ResponsiveNavLink from "@/Components/ResponsiveNavLink";
export default function MerchantResponsiveNav({}) {
  return (
    <>
      <ResponsiveNavLink
        href={route('merchant.transactions')}
        active={route().current('merchant.transactions')}
      >
        Transactions
      </ResponsiveNavLink>
      <ResponsiveNavLink
        href={route('merchant.money.add')}
        active={route().current('merchant.money.add')}
      >
        Add Money
      </ResponsiveNavLink>
      <ResponsiveNavLink
        href={route('merchant.money.send')}
        active={route().current('merchant.money.send')}
      >
        Send Money
      </ResponsiveNavLink>
      </>
  );
}
