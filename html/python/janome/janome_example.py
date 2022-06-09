#!/usr/bin/python3
# -- coding: utf-8 --
from janome.tokenizer import Tokenizer
import io,sys

t = Tokenizer()

s = sys.argv[1]

for token in t.tokenize(s):
    print(token.base_form + " " + token.part_of_speech.split(',')[0])
