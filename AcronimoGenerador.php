<?php

require_once 'Acrointerface.php';
require_once 'EliminarTxt.php';

class AcronimoGenerador implements Acrointerface
{
    private EliminarTxt $textProcessor;
    
    
    public function __construct(EliminarTxt $textProcessor)
    {
        $this->textProcessor = $textProcessor;
    }
    
   
    public function generateAcronym(string $phrase): string
    {
        $cleanedPhrase = $this->textProcessor->cleanText($phrase);
        
        $normalizedPhrase = $this->textProcessor->normalizeSeparators($cleanedPhrase);
        
        $words = $this->textProcessor->splitIntoWords($normalizedPhrase);
        
        $acronym = '';
        foreach ($words as $word) {
            $word = trim($word);
            if (!empty($word)) {
                $acronym .= strtoupper($word[0]);
            }
        }
        
        return $acronym;
    }
}
