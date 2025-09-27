<?php


class EliminarTxt
{
  
    public function cleanText(string $text): string
    {
        $cleaned = preg_replace('/[^\w\s\-]/', '', $text);
        
        $cleaned = preg_replace('/[\s\-]+/', ' ', $cleaned);
        
        return trim($cleaned);
    }
    
    
    public function normalizeSeparators(string $text): string
    {
        return str_replace('-', ' ', $text);
    }
    
    
    public function splitIntoWords(string $text): array
    {
        return explode(' ', $text);
    }
}
