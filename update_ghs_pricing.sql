-- Update pricing to Ghanaian Cedis (GHS) matching individual course pages
-- Exchange rate approximately: 1 USD = 15 GHS

UPDATE courses SET price=4485.00 WHERE slug='frontend';        -- Was $299, now GHS 4,485
UPDATE courses SET price=5235.00 WHERE slug='backend';         -- Was $349, now GHS 5,235
UPDATE courses SET price=7485.00 WHERE slug='fullstack';       -- Was $499, now GHS 7,485
UPDATE courses SET price=8985.00 WHERE slug='ai';              -- Was $599, now GHS 8,985
UPDATE courses SET price=8235.00 WHERE slug='data-science';    -- Was $549, now GHS 8,235
UPDATE courses SET price=5985.00 WHERE slug='mobile';          -- Was $399, now GHS 5,985
UPDATE courses SET price=6735.00 WHERE slug='cloud';           -- Was $449, now GHS 6,735 (bundle GHS 13,500)
UPDATE courses SET price=7185.00 WHERE slug='cybersecurity';   -- Was $479, now GHS 7,185 (bundle GHS 15,500)
UPDATE courses SET price=3735.00 WHERE slug='database';        -- Was $249, now GHS 3,735 (bundle GHS 2,520 - 4 courses)
UPDATE courses SET price=2235.00 WHERE slug='microsoft-office';-- Was $149, now GHS 2,235
UPDATE courses SET price=2985.00 WHERE slug='networking';      -- Was $199, now GHS 2,985
UPDATE courses SET price=2685.00 WHERE slug='hardware';        -- Was $179, now GHS 2,685
UPDATE courses SET price=1485.00 WHERE slug='digital-literacy';-- Was $99, now GHS 1,485
UPDATE courses SET price=4185.00 WHERE slug='video-editing';   -- Was $279, now GHS 4,185
UPDATE courses SET price=3885.00 WHERE slug='graphic-design';  -- Was $259, now GHS 3,885
