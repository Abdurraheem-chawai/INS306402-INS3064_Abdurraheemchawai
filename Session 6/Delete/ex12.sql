DELETE FROM orders
WHERE status = 'Shipped'
  AND order_date < '2026-03-05';