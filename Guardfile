# A sample Guardfile
# More info at https://github.com/guard/guard#readme

guard 'sass', :input => 'public/css'
guard 'coffeescript', :input => 'public/js'

guard 'process', :name => 'Minify application javascript', :command => 'juicer merge public/js/functions.js --force -s' do
  watch %r{public/js/models/(.+)\.js}
end