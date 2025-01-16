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
    </>
  );
}
