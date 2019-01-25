<?php

abstract class QueryCommon {
    public abstract function from() : string;
    public abstract function where() : string;
}