TRUNCATE `daily_log`;

INSERT INTO
	`daily_log`
    (`date`, `containerQty`)

SELECT
	`stuffingDate`,
    COUNT(*) qty
FROM
	`jobContainer`
WHERE
	`stuffingDate` IS NOT NULL
GROUP BY
	`stuffingDate`;