import NavLink from "@/Components/NavLink";
export default function MerchantNav({}) {
  return (
    <>
      <NavLink
        href={route('merchant.transactions.index')}
        active={route().current("merchant.transactions.index")}
      >
        Transactions
      </NavLink>
    </>
  );
}
