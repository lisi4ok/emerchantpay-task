import ResponsiveNavLink from "@/Components/ResponsiveNavLink";
export default function MerchantResponsiveNav({}) {
  return (
    <>
      <ResponsiveNavLink
        href={route('merchant.transactions.index')}
        active={route().current('merchant.transactions.index')}
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
