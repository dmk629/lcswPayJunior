<?php
/**
 * Custom global functions
 */

function user_func(): string
{
    return 'hello';
}

function formatResponse(bool $status, int $errcode, $data)
{
    return Swoft\Context\Context::mustGet()->getResponse()->withData(["status"=>$status,"errcode"=>$errcode,"data"=>$data]);
}