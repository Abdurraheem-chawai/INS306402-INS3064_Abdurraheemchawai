SELECT 
    o.id,
    u.name,
    p.name,
    oi.quantity,
    p.price
FROM orders o
JOIN users u ON o.user_id = u.id
JOIN order_items oi ON o.id = oi.order_id
JOIN products p ON oi.product_id = p.id
WHERE o.status = 'delivered'
ORDER BY o.id, p.id;