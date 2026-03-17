SELECT 
    c.name AS category_name,
    SUM(oi.price * oi.quantity) AS revenue
FROM categories c
JOIN products p ON c.id = p.category_id
JOIN order_items oi ON p.id = oi.product_id
JOIN orders o ON oi.order_id = o.id
WHERE o.status = 'delivered'
GROUP BY c.id
HAVING SUM(oi.price * oi.quantity) > 1000
ORDER BY revenue DESC;