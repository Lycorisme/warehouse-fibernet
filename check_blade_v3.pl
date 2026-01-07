
$file = 'c:\laragon\www\warehouse-fibernet\resources\views\Master\Akses\index.blade.php';
open(my $fh, '<', $file) or die $!;
my @stack;
while (my $line = <$fh>) {
    $. = $.;
    while ($line =~ /(@[a-z]+)/g) {
        my $match = $1;
        if ($match =~ /^@(if|foreach|section|php|auth|guest|unless|for|while|isset|empty)$/) {
             push @stack, [$match, $.];
        } elsif ($match =~ /^@end(if|foreach|section|php|auth|guest|unless|for|while|isset|empty)$/) {
            my $expected = $match;
            $expected =~ s/end//;
            if (!@stack) {
                print "Line $.: Unexpected $match\n";
            } else {
                my $top = pop @stack;
                if ($top->[0] ne $expected) {
                    print "Line $.: Mismatched $match (expected $top->[0] from line $top->[1])\n";
                }
            }
        }
    }
}
for my $rem (@stack) {
    print "Unclosed $rem->[0] from line $rem->[1]\n";
}
