-- Update pricing to match bundle prices on individual course track pages
-- These are bundle prices for complete learning tracks

UPDATE courses SET price=3800.00 WHERE slug='frontend';        -- Frontend Bundle: GHS 3,800 (6 courses)
UPDATE courses SET price=4850.00 WHERE slug='backend';         -- Backend Bundle: GHS 4,850 (6 courses)
UPDATE courses SET price=7485.00 WHERE slug='fullstack';       -- Full Stack (keep as is)
UPDATE courses SET price=8985.00 WHERE slug='ai';              -- AI (keep as is)
UPDATE courses SET price=8235.00 WHERE slug='data-science';    -- Data Science (keep as is)
UPDATE courses SET price=5985.00 WHERE slug='mobile';          -- Mobile (keep as is)
UPDATE courses SET price=13500.00 WHERE slug='cloud';          -- Cloud Bundle: GHS 13,500 (6 courses)
UPDATE courses SET price=15500.00 WHERE slug='cybersecurity';  -- Cybersecurity Bundle: GHS 15,500 (6 courses)
UPDATE courses SET price=2520.00 WHERE slug='database';        -- Database Bundle: GHS 2,520 (4 courses)
UPDATE courses SET price=2235.00 WHERE slug='microsoft-office';-- Microsoft Office (keep as is)
UPDATE courses SET price=2985.00 WHERE slug='networking';      -- Networking (keep as is)
UPDATE courses SET price=2685.00 WHERE slug='hardware';        -- Hardware (keep as is)
UPDATE courses SET price=1485.00 WHERE slug='digital-literacy';-- Digital Literacy (keep as is)
UPDATE courses SET price=4185.00 WHERE slug='video-editing';   -- Video Editing (keep as is)
UPDATE courses SET price=3885.00 WHERE slug='graphic-design';  -- Graphic Design (keep as is)
