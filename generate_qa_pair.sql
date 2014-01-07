CREATE FUNCTION generate_qa_pair
	(OUT question character varying, OUT answers character varying) 
RETURNS record
LANGUAGE plpgsql
AS 
$$
declare random_card_id int;
	question_pool int;
begin
	select count(*) into question_pool from card;
	random_card_id := ceiling(random()*question_pool);

	select card.question_text, answer.answer_text into question, answers 
		from card join answer on card.card_id=answer.card_id
		where card.card_id=random_card_id
		limit 1;
end
$$;
