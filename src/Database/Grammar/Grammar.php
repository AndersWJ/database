<?php

namespace Awj\Database\Grammar;

abstract class Grammar
{
    public function compileSelect($table, $columns)
    {
        $columns = implode(',', $columns);

        return sprintf('select %s from %s', $columns, $table);
    }
}
