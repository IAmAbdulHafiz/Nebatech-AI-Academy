-- Update pricing to EXACTLY match individual course pages
-- These prices are from the bundle pricing banners on each page

UPDATE courses SET price=3800.00 WHERE slug='frontend';        -- GHS 3,800 ✓
UPDATE courses SET price=4850.00 WHERE slug='backend';         -- GHS 4,850 ✓
UPDATE courses SET price=8300.00 WHERE slug='fullstack';       -- GHS 8,300
UPDATE courses SET price=6900.00 WHERE slug='ai';              -- GHS 6,900
UPDATE courses SET price=9200.00 WHERE slug='data-science';    -- GHS 9,200
UPDATE courses SET price=12500.00 WHERE slug='mobile';         -- GHS 12,500
UPDATE courses SET price=13500.00 WHERE slug='cloud';          -- GHS 13,500 ✓
UPDATE courses SET price=15500.00 WHERE slug='cybersecurity';  -- GHS 15,500 ✓
UPDATE courses SET price=2520.00 WHERE slug='database';        -- GHS 2,520 ✓
UPDATE courses SET price=2280.00 WHERE slug='microsoft-office';-- GHS 2,280
UPDATE courses SET price=3190.00 WHERE slug='networking';      -- GHS 3,190
UPDATE courses SET price=1560.00 WHERE slug='hardware';        -- GHS 1,560
UPDATE courses SET price=1200.00 WHERE slug='digital-literacy';-- GHS 1,200
UPDATE courses SET price=1790.00 WHERE slug='video-editing';   -- GHS 1,790
UPDATE courses SET price=1980.00 WHERE slug='graphic-design';  -- GHS 1,980
