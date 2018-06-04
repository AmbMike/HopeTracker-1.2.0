/** Run this to see duplicated content columns
    Delete only rows that have the same content.IMPORTANT,leave one of the duplicated post.
*/
select * from journal_entries where content in (
    select content from journal_entries
    group by content having count(*) > 1
)

/** Run this to see duplicated titles and user id columns
    Delete only rows that have the same content.IMPORTANT,leave one of the duplicated post.
*/
select  *
from journal_entries s
join (
    select user_id, title
    from journal_entries
    group by user_id, title
    having count(*) > 1
) t on s.user_id = t.user_id and s.title = t.title
20,46