
$file = 'c:\laragon\www\warehouse-fibernet\resources\views\Master\Akses\index.blade.php';
open(my $fh, '<', $file) or die $!;
my @stack;
while (my $line = <$fh>) {
    $. = $.;
    while ($line =~ /(@if|@endif|@foreach|@endforeach|@section|@endsection|@php|@endphp|@auth|@endauth|@guest|@endguest)\b/g) {
        my $match = $1;
        if ($match =~ /^@end/) {
            my $expected = $match;
            $expected =~ s/end//;
            if (!@stack) {
                print "Line $.: Unexpected $match\n";
            } else {
                my $top = pop @stack;
                if ($top->[0] ne $expected) {
                    print "Line $.: Mismatched $match (expected closure for $top->[0] from line $top->[1])\n";
                }
            }
        } else {
            push @stack, [$match, $.];
        }
    }
}
for my $rem (@stack) {
    print "Unclosed $rem->[0] from line $rem->[1]\n";
}
