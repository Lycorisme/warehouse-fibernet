
$file = 'c:\laragon\www\warehouse-fibernet\resources\views\Master\Akses\index.blade.php';
open(my $fh, '<', $file) or die "Could not open file '$file' $!";

my @stack = ();
my $line_num = 0;

while (my $line = <$fh>) {
    $line_num++;
    
    # regex for directives
    while ($line =~ /(@if|@foreach|@section|@php|@auth|@guest|@endif|@endforeach|@endsection|@endphp|@endauth|@endguest)\b/g) {
        my $match = $1;
        if ($match =~ /^@end/) {
            my $expected = $match;
            $expected =~ s/end//;
            if (@stack == 0) {
                print "ERROR: Unexpected $match at line $line_num\n";
            } else {
                my $top = pop @stack;
                if ($top->{type} ne $expected) {
                    print "ERROR: Mismatched $match at line $line_num (expected closure for $top->{type} from line $top->{line})\n";
                }
            }
        } else {
            push @stack, { type => $match, line => $line_num };
        }
    }
}

while (@stack > 0) {
    my $top = pop @stack;
    print "ERROR: Unclosed $top->{type} from line $top->{line}\n";
}
