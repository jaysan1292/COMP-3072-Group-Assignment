# Workaround for 'compass watch' not working properly under Ruby+Cygwin
# Depends on the watchr gem to be installed `gem install watchr`
watch:
	watchr -e "watch('sass/.*') { puts 'update'; system('compass compile') }"
