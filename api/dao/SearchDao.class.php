<?php

require_once __DIR__ . '/../dao/Dao.class.php';

class SearchDAO extends Dao
{
    public function searchGamesByName($term, $limit, $page)
    {
        $offset = $limit * ($page - 1);
        $term = '%'.$term.'%';

        $sql = "
            select
                g.id,
                g.name,
                g.release_date,
                g.description,
                g.relevance,
                group_concat(d.name separator ', ') as 'developers',
                group_concat(p.name separator ', ') as 'platforms'
            from
                game g
            inner join game_developer gd	on g.id = gd.game_id
            inner join developer d			on gd.developer_id = d.id
            inner join game_platform gp		on g.id = gp.game_id
            inner join platform p			on gp.platform_id = p.id
            where
                g.name like ?
            group by
                g.id, g.name, g.release_date, g.relevance, g.description
            order by
                g.relevance desc
            limit ? offset ?;
        ";

        return $this->executeQuery($sql, 'sii', [$term, $limit, $offset]);
    }

    public function searchPlatformsByName($term, $limit)
    {
        $term = '%' . $term . '%';
        $sql = "
            select
                p.id,
                p.name
            from
                platform p
            where
                p.name like ?
            order by
                p.relevance
                desc
            limit ?;
        ";
        return $this->executeQuery($sql, 'si', [$term, $limit]);
    }

    public function searchDevelopersByName($term, $limit)
    {
        $term = '%' . $term . '%';
        $sql = "
            select 
                d.id,
                d.name
            from
                developer d
            where
                d.name like ?
            limit ?;
        ";
        
        return $this->executeQuery($sql, 'si', [$term, $limit]);
    }
}