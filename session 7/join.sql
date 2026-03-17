SELECT 
    p.id,
    p.name,
    p.price,
    COALESCE(c.category_name, 'No category') AS category_name
FROM products p
LEFT JOIN categories c 
    ON p.category_id = c.id
ORDER BY p.id;