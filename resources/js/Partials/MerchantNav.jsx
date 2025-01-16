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
      <NavLink
        href={route('merchant.money.add')}
        active={route().current("merchant.money.add")}
      >
        Add Money
      </NavLink>
      <NavLink
        href={route('merchant.money.transfer')}
        active={route().current("merchant.money.transfer")}
      >
        Send Money
      </NavLink>
    </>
  );
}
