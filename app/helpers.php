<?php

function uuid()
{
    return Ramsey\Uuid\Uuid::uuid4()->toString();
}