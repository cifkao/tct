all: abstract.pdf
	# Rough estimate of words in the PDF:
	@pdftotext $< - \
	| ./skipbetween --inv Introduction References \
	| wc -w

# %.eps: %.dot
# 	dot -Tps $< > $@
# 
# .PRECIOUS: %.eps
# %.pdf: %.eps
# 	ps2pdf $< $@

LATEX=pdflatex
%.pdf: %.tex
	$(LATEX) $<
	bibtex $* || echo "Bibtex failed"
	lim=4; \
	  while [ $$lim -ge 0 ] \
	      && grep 'Rerun to get cross-references right.\|Citation.*undefined' $*.log >/dev/null 2>/dev/null; do \
	    $(LATEX) $< ; \
	    lim=$$(($$lim - 1)) ; \
	  done
