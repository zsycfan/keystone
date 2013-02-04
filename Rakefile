task :compile do
  # Delete the original file
  File.delete 'public/js/functions.js'

  # Add the JS libraries
  File.open 'public/js/functions.js', 'a' do |js|
    js.puts Dir.glob(File.join("public/js/**", "*.js")).sort.map{|f| IO.read f}
  end

  # Merge our coffee script
  File.open("public/js/functions.compiled", 'w') do |js|
    js.puts Dir.glob(File.join("public/js/**", "*.coffee")).sort.map{|f| IO.read f}
  end

  # Add in the compiled JS
  File.open 'public/js/functions.js', 'a' do |js|
    js.write `coffee -p public/js/functions.compiled`
  end

  # Delete the merged coffee script
  File.delete 'public/js/functions.compiled'
end

task :document do
  Dir.glob('libraries**/*.php').each do |f|
    file = File.open(f, "rb")
    contents = file.read
    if contents.include?('/**') then
      comments = []
      contents.gsub(/\/\*\*.*?\*\//m) do |match|
        comments.push match.gsub(/^[[:blank:]]*(\/\*\*|\*\/|\*)[[:blank:]]*/m, '')
      end
      File.open(f.gsub(/\.php$/, '.md'), 'w') {|f| f.write(comments.join("\r\n").strip) }
    end
  end
end