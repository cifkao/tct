UPDATE translations SET translations.scoring_count = (SELECT COUNT(scorings.id) FROM scorings WHERE scorings.translation_id = translations.id AND scorings.result IS NOT NULL);
