import NavLink from "@/Components/NavLink";
export default function MerchantNav({}) {
  return (
    <>
      <NavLink
        href={route('merchant.transactions')}
        active={route().current("merchant.transactions")}
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
        href={route('merchant.money.send')}
        active={route().current("merchant.money.send")}
      >
        Send Money
      </NavLink>
    </>
  );
}
