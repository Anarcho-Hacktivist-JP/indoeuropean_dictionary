# encoding: utf-8
import sys
import re
from find_applicable_sandhis import FindApplicableSandhis


class SandhiEngine:
    """

    """
    def __init__(self, language):
        # self.language = language
        self.find = FindApplicableSandhis(language)

    def apply_sandhi(self, current_word, next_word):
         # 変換処理
        current_word = self.iast_to_harvard_kyoto(current_word)
        next_word = self.iast_to_harvard_kyoto(next_word)       
        applied = []
        possible_sandhis = self.find_sandhis_for(current_word, next_word)
        if possible_sandhis:
            for sandhi in possible_sandhis:
                sandhied_current_word, rest = sandhi.split(',')
                possible_lemmas = rest.split('|')
                for lemma_diff in possible_lemmas:
                    lemma_diff = lemma_diff.split('=')[0]  # remove the sandhi type information
                    new_initial_diff = lemma_diff.split('/')[1]
                    if new_initial_diff == '':
                        sandhied_current_word = self.harvard_kyoto_to_iast(sandhied_current_word)
                        next_word = self.harvard_kyoto_to_iast(next_word)                         
                        applied.append(sandhied_current_word + next_word)
                    else:
                        sandhied_initial, unsandhied_initials = new_initial_diff.lstrip('-').split('+')
                        sandhied_next_word = sandhied_initial + next_word.lstrip(unsandhied_initials)
                        sandhied_current_word = self.harvard_kyoto_to_iast(sandhied_current_word)
                        sandhied_next_word = self.harvard_kyoto_to_iast(sandhied_next_word)                             
                        applied.append(sandhied_current_word + sandhied_next_word)
        else:
            current_word = self.harvard_kyoto_to_iast(current_word)
            next_word = self.harvard_kyoto_to_iast(next_word)                
            applied.append(current_word + next_word)
        return applied

    def find_sandhis_for(self, word1, word2):
        if len(word2) > 0:
            initial_char = word2[0]
        else:
            initial_char = word2
        all_potential_sandhis = self.find.all_possible_sandhis(word1)

        formatted_possible_lemmas = []
        for potential_sandhi in all_potential_sandhis:
            sandhied, rest = potential_sandhi.split(',')
            potential_lemma_diffs = rest.split('|')

            possible_lemmas = []
            for potential_diff in potential_lemma_diffs:
                initials_of_potential_lemma = potential_diff.split('$')[0].split(':')
                if initial_char in initials_of_potential_lemma:
                    possible_lemmas.append(potential_diff)

            if possible_lemmas:
                formatted_possible_lemmas.append('{},{}'.format(sandhied, '|'.join(possible_lemmas)))

        if formatted_possible_lemmas:
            return formatted_possible_lemmas
        return None

    # 京都ハーバード方式に変換
    def iast_to_harvard_kyoto(self, target_word):
        # 母音変換
        target_word = target_word.replace('ā', 'A').replace('ī', 'I').replace('ū', 'U').replace('ṛ', 'R').replace('ṝ', 'RR').replace('ṃ', 'M').replace('ḥ', 'H')
        # 子音変換
        target_word = target_word.replace('ś', 'z').replace('ṣ', 'S').replace('ñ', 'J').replace('ṅ', 'G').replace('ṭ', 'T').replace('ḍ', 'D')
        #print(target_word)
        return target_word

    # IAST方式に変換
    def harvard_kyoto_to_iast(self, target_word):
        # 母音変換
        target_word = target_word.replace('A', 'ā').replace('I', 'ī').replace('U', 'ū').replace('E', 'e').replace('RR', 'ṝ').replace('R', 'ṛ').replace('M', 'ṃ').replace('H', 'ḥ')
        # 子音変換
        target_word = target_word.replace('z', 'ś').replace('S', 'ṣ').replace('J', 'ñ').replace('G', 'ṅ').replace('T', 'ṭ').replace('D', 'ḍ').replace('nn', 'n')
        #print(target_word)        
        return target_word


if __name__ == "__main__":
    lang = 'sanskrit'
    engine = SandhiEngine(lang)

    args = sys.argv
    if len(args) == 3:
        word1 = args[1]
        word2 = args[2]
        # print('{} + {} =>'.format(word1, word2), ', '.join(engine.apply_sandhi(word1, word2)))
        print(engine.apply_sandhi(word1, word2))
    else:
        print('Usage: sandhi_engine.py <word1> <word2>\nNote: enter an empty string ('') for final sandhis')
        print('\nRunning demo:')
        currents = ['Darma', 'Darman', 'rAma', 'rAmoh', 'rAmoH', 'rAmo', 'rAm']
        initial = 'asti'
        for c in currents:
            print('{} + {} =>'.format(c, initial), ', '.join(engine.apply_sandhi(c, initial)))
        c, initial = 'tattva', 'Ikzina'
        print('{} + {} =>'.format(c, initial), ', '.join(engine.apply_sandhi(c, initial)))
