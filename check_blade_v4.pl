
$file = 'c:\laragon\www\warehouse-fibernet\resources\views\Master\Akses\index.blade.php';
open(my $fh, '<', $file) or die $!;
my $content = do { local $/; <$fh> };
close($fh);

# Replace balanced blocks with markers
while ($content =~ s/@if\b((?:(?>[^@]+)|(?R)|@(?:else|elseif)\b)*)@endif\b/[IF_BLOCK]/gs) {}
while ($content =~ s/@foreach\b((?:(?>[^@]+)|(?R))*)@endforeach\b/[FOREACH_BLOCK]/gs) {}
while ($content =~ s/@section\b((?:(?>[^@]+)|(?R))*)@endsection\b/[SECTION_BLOCK]/gs) {}

print "Remaining content with directives:\n";
while ($content =~ /(@[a-z]+)/g) {
    print "$1\n";
}
