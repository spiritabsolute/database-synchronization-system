<?php
namespace App;

interface Entity
{
	public function getType(): string;

	public function getFields(): array;

	public function getHashInput(): string;
}