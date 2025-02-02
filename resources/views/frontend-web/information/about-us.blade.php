<!DOCTYPE html>
<html lang="ja">
  <head>
   @include('frontend-web.partials.seo') 
  </head>
  
  <body>
    <div style="display: none">
        @include('frontend-web.partials.header')
    </div>

    <div class="mx-auto max-w-screen-2xl">
        <div class="h-8 sm:h-11 2xl:overflow-visible overflow-clip"></div>
        
        @include('frontend-web.partials.header')

        <div class="overflow-x-clip"><article class="md:my-10 my-8 2xl:px-[0px] px-5 prose prose-invert mx-auto">
          <h1><strong _msttexthash="10323430" _msthash="19">我々について</strong></h1>
          <p _msttexthash="1335750741" _msthash="20">ノヴァマンガへようこそ、マンガのすべてのためのあなたの最高の目的地!{{ config('custom.frontend_name') }}では、マンガ愛好家に、お気に入りのストーリーやキャラクターを探索し、発見し、ふけるためのプラットフォームを提供することに情熱を注いでいます。</p>
          <p _msttexthash="1989554749" _msthash="21">熱心なマンガ愛好家のチームによって設立された{{ config('custom.frontend_name') }}は、マンガ文化の豊かなタペストリーを祝うという共通の献身から生まれました。芸術形式への深い感謝の念から、多様な趣味や興味に応える比類のないマンガタイトルのコレクションをキュレーションするよう努めています。</p>
          <p _msttexthash="1392825746" _msthash="22">{{ config('custom.frontend_name') }}のミッションはシンプルで、世界中のマンガ愛好家のための究極のオンラインハブになることです。ベテランのマンガのベテランでも、好奇心旺盛な新人でも、日本のコミックの魅惑的な領域を旅する旅に同行します。</p>
          <p _msttexthash="2525832426" _msthash="23">{{ config('custom.frontend_name') }}を際立たせているのは、品質、多様性、アクセシビリティへの取り組みです。私たちは出版社やクリエイターと直接協力して、不朽の名作とともに最新作を誇るライブラリを確保しています。アクション満載の少年叙事詩から心温まる人生の断片の物語まで、誰もが楽しめるものを用意しています。</p>
          <p _msttexthash="2973150752" _msthash="24">しかし、{{ config('custom.frontend_name') }}は豊富なカタログを提供するだけではありません。それは、活気あるコミュニティを育むことです。会員同士の活発な議論、ファン理論、芸術表現を奨励しています。ブログ、フォーラム、ソーシャルメディアチャンネルを通じて、あらゆる分野のマンガ愛好家をつなぎ、仲間意識と帰属意識を育むことを目指しています。</p>
          <p _msttexthash="4011671443" _msthash="25">ノヴァマンガでは、ユーザーエクスペリエンスを何よりも優先しています。当社のウェブサイトは、洗練され、直感的で、ユーザーフレンドリーに設計されているため、ナビゲートしたり、新しいタイトルを発見したり、個人のマンガコレクションを構築したりするのが簡単です。コンピューター、タブレット、スマートフォンのいずれで読む場合でも、すべてのデバイスでシームレスにアクセスできるようにプラットフォームを最適化しました。</p>
          <p _msttexthash="1097375162" _msthash="26">マンガの世界は、特に初心者にとって、広大で圧倒される可能性があることを理解しています。そのため、専任の専門家チームを編成し、常に推奨事項を提供し、質問に答え、マンガの旅を案内します。</p>
          <p _msttexthash="2007460884" _msthash="27">マンガエンターテインメントの信頼できる情報源として{{ config('custom.frontend_name') }}をお選びいただきありがとうございます。冒険、ロマンス、コメディ、ドラマのいずれを求めている場合でも、私たちと一緒に魅惑的なマンガの世界に没頭してください。今すぐコミュニティに参加して、冒険を始めましょう!</p>
          </article>
        </div>

      </div>

      @include('frontend-web.partials.footer', ['generalIntroduction' => false])

    <script src="{{ asset('frontend-web/js/index.js') }}" type="text/javascript"></script>
    <foreignobject></foreignobject>
  </body>
</html>